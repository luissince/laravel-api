docker stop api-gateway && docker rm api-gateway

docker image rm api-gateway

docker build -t api-gateway .

docker run -d --name api-gateway --net=my-net -p 8000:80 api-gateway