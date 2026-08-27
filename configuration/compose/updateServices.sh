
arr=(../../services/*)
arr=("${arr[@]%/}")
arr=("${arr[@]##*/}")
# find modules modules
for y in "${arr[@]}"
do  
    echo "update modules in ${y}"
    modules=(../../services/${y}/*)
    modules=("${modules[@]%/}")
    modules=("${modules[@]##*/}")

    # initiate modules
    for n in "${modules[@]}"
    do

        cp startup/Dockerfile ../../services/${y}/${n}/Dockerfile
        cp startup/migrate.sh ../../services/${y}/${n}/nginx/migrate.sh
        cp -R ../../helpers/providers/. ../../services/${y}/${n}/app/Providers

    done
done