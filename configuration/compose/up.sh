read -r -p "Please input destination URL (default stafflify.test): " x
x=${x:-stafflify.test}
read -r -p "Do you want to update local machines hosts file? [Y/n]: " updateHosts
updateHosts=${updateHosts:-y}
read -r -p "Do you want to update services with latest version providers? [y/N]: " updateServices
updateServices=${updateServices:-n}
read -r -p "Delete dangling docker images (if you use docker for something else, this is not recomended)? [y/N]: " deleteDangling
deleteDangling=${updateServices:-n}
# init UI
   
git update-index --assume-unchanged docker-compose.yaml

if [[ "$updateHosts" =~ ^([yY][eE][sS]|[yY])$ ]]
then
    if grep -Fq "127.0.0.1       ${x}" /etc/hosts
    then
        echo "UI is already implimented in hosts"
    else
        sudo echo "127.0.0.1       ${x}" >> /etc/hosts
        sudo echo "127.0.0.1       tenant1.${x}" >> /etc/hosts
        sudo echo "127.0.0.1       tenant2.${x}" >> /etc/hosts
    fi
fi

if [[ "$updateHosts" =~ ^([yY][eE][sS]|[yY])$ ]]
then
    if grep -Fq "127.0.0.1       cdn.${x}" /etc/hosts
    then
        echo "CDN is already implimented in hosts"
    else
        sudo echo "127.0.0.1       cdn.${x}" >> /etc/hosts
        sudo echo "127.0.0.1       cdn.tenant1.${x}" >> /etc/hosts
        sudo echo "127.0.0.1       cdn.tenant2.${x}" >> /etc/hosts
    fi
fi

if [[ "$updateServices" =~ ^([yY][eE][sS]|[yY])$ ]]
then
    sh updateServices.sh
fi

sed 's/SITEURL/$http_origin/g' nginx/site.conf > nginx/default.conf

arr=(../../services/*)
arr=("${arr[@]%/}")
arr=("${arr[@]##*/}")
# find modules modules
for y in "${arr[@]}"
do  
    echo "initiating modules in ${y}"
    modules=(../../services/${y}/*)
    modules=("${modules[@]%/}")
    modules=("${modules[@]##*/}")

    # initiate modules
    for n in "${modules[@]}"
    do

        cp nginx/default.conf ../../services/${y}/${n}/nginx/default.conf
        cp nginx/start.sh ../../services/${y}/${n}/nginx/start.sh
        cp nginx/runningProcess.sh ../../services/${y}/${n}/nginx/runningProcess.sh

        if [[ "$updateHosts" =~ ^([yY][eE][sS]|[yY])$ ]]
        then
            if grep -Fq "${n}.${x}" /etc/hosts
            then
                echo "${n} is already implimented in hosts"
            else
                sudo echo "127.0.0.1       ${n}.${x}" >> /etc/hosts
                sudo echo "127.0.0.1       ${n}.tenant1.${x}" >> /etc/hosts
                sudo echo "127.0.0.1       ${n}.tenant2.${x}" >> /etc/hosts
            fi
        fi

        if grep -Fq "$n.$x" docker-compose.yaml
        then
            echo "${n} is already implimented in docker-compose"
        else
            upperstr=$(echo $n | tr '[:lower:]' '[:upper:]')
            sudo echo "#-------------------------------------$upperstr-------------------------------------#" >> docker-compose.yaml
            sudo echo "  ${n}:" >> docker-compose.yaml
            sudo echo "    volumes:" >> docker-compose.yaml
            sudo echo "      - ../../services/${y}/${n}:/usr/share/nginx/html" >> docker-compose.yaml
            sudo echo "      - /usr/share/nginx/html/vendor/" >> docker-compose.yaml
            sudo echo "    build: ../../services/${y}/${n}" >> docker-compose.yaml
            sudo echo "    restart: always" >> docker-compose.yaml
            sudo echo "    #----TRÆFIK PROXY----#" >> docker-compose.yaml
            sudo echo "    labels:" >> docker-compose.yaml
            sudo echo '      - "traefik.http.middlewares.'$n'.redirectscheme.scheme=https"' >> docker-compose.yaml
            sudo echo '      - "traefik.enable=true"' >> docker-compose.yaml
            sudo echo '      - "traefik.http.routers.'$n'.priority=42"' >> docker-compose.yaml
            sudo echo '      - "traefik.http.routers.'$n'.rule=HostRegexp(`'$n'.'$x'`)"' >> docker-compose.yaml
            sudo echo '      - "traefik.http.routers.'$n'.entrypoints=web"' >> docker-compose.yaml
            sudo echo '      - "traefik.http.routers.'$n'.entrypoints=websecure"' >> docker-compose.yaml
            sudo echo '      - "traefik.http.routers.'$n'.tls=true"' >> docker-compose.yaml
            sudo echo '    networks:' >> docker-compose.yaml
            sudo echo '      - app-network' >> docker-compose.yaml
            sudo echo '    depends_on:' >> docker-compose.yaml
            sudo echo '      - mariadb' >> docker-compose.yaml
        fi
    done
done

docker compose -p="stafflify" up -d --build

if [[ "$deleteDangling" =~ ^([yY][eE][sS]|[yY])$ ]]
then
    echo 'Deleting clutter images'
    docker image prune -f
fi

sh migrate.sh
