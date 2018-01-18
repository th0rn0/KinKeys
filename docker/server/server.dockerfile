FROM nginx:1.10

ADD vhost.conf /etc/nginx/conf.d/default.conf
COPY nginx.conf /etc/nginx/nginx.conf