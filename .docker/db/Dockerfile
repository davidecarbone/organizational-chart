FROM mysql

MAINTAINER me

#ENV MYSQL_DATABASE=<schema_name> \
#    MYSQL_ROOT_PASSWORD=<password>

ADD db/schema.sql /docker-entrypoint-initdb.d

EXPOSE 3306
