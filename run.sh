docker stop php-app && docker rm php-app

docker image rm php-app

docker build -t php-app .

docker run -d --name php-app --net=my-net -p 8000:80 php-app