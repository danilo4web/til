# version
docker --version

# to list up containers
docker container ls

# to list all containers
docker container ls -a

# list all
docker (image | container | volume) ls -a

# name
docker container run --name meu-debian -it debian bash

# rm
docker container run --rm -it debian bash

# start
docker container start -ai meu-debian

# to map ports
docker container run -p 8080:80 -it nginx --name server-nginx

# 8080:80 and symbolic link to local folder
docker container run -d --name MY_NGINX -p 8080:80 -v $(pwd)/html:/usr/share/nginx/html nginx

# handling containers
docker container ( start | stop | restart | logs | inspect) MY_NGINX

# execute short commands
docker container exec MY_NGINX uname -r

# list all
docker (image | container | volume) ls -a

# build
docker image build -t BUILD_NAME .

# mapping port 80
 docker container run -p 8080:80 BUILD_NAME

# Dockerfile
FROM nginx:latest
RUN echo '<h1>Hello World !</h1>' > /usr/share/nginx/html/index.html

# repository
http://hub.docker.com