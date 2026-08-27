arr=(../../services/*)
arr=("${arr[@]%/}")
arr=("${arr[@]##*/}")
# find modules modules
for y in "${arr[@]}"
do  
    echo "migrating modules in ${y}"
    modules=(../../services/${y}/*)
    modules=("${modules[@]%/}")
    modules=("${modules[@]##*/}")

    # initiate modules
    for n in "${modules[@]}"
    do
        echo "awaiting migration in module ${n}"
        docker exec stafflify-$n-1 php usr/share/nginx/html/artisan app:init
    done
done