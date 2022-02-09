FROM ubuntu:16.04
MAINTAINER jee.archer@gmail.com

ARG HHVM_PACKAGE
ARG HHVM_REPO_DISTRO=xenial
ENV HHVM_DISABLE_NUMA true

RUN apt-get update -y && apt-get install -y software-properties-common apt-transport-https \
  && apt-key adv --recv-keys --keyserver hkp://keyserver.ubuntu.com:80 0xB4112585D386EB94 \
#  && add-apt-repository "deb https://s3-us-west-2.amazonaws.com/hhvm-downloads/ubuntu ${HHVM_REPO_DISTRO} main" \
  && add-apt-repository "deb http://dl.hhvm.com/ubuntu ${HHVM_REPO_DISTRO} main" \
  && apt-get update -y --fix-missing \
  && apt-get install -y ${HHVM_PACKAGE} git wget curl \
  && apt-get install -y hhvm nano \
  && apt-get clean \
  && rm -rf /var/lib/apt/lists/*

RUN usermod -u 1000 www-data

COPY config/php.ini /etc/hhvm/php.ini
COPY config/server.ini /etc/hhvm/server.ini

#USER www-data
CMD ["/usr/bin/hhvm", "--user", "root", "-m", "server", "-c", "/etc/hhvm/server.ini"]