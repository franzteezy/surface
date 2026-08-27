process=$(ps aux | grep [q]ueue:work)
if [ -z "$process" ]
then
      nohup php /usr/share/nginx/html/artisan queue:listen &
fi
