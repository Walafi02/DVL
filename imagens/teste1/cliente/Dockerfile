FROM ubuntu:16.04
MAINTAINER walafif@yahoo.com

RUN apt-get update
RUN apt-get install -y nano
RUN apt-get install -y net-tools
RUN apt-get install -y iputils-ping
RUN apt-get install -y sudo
RUN apt-get clean

RUN addgroup alunos
RUN useradd aluno -g alunos -s /bin/bash -m
RUN echo aluno:alunoufc > senhas.txt
RUN chpasswd < senhas.txt
RUN rm senhas.txt

RUN echo "%alunos  ALL=(ALL) NOPASSWD: ALL" >> /etc/sudoers
RUN sed -ie "s/60$/3600/g" /etc/login.defs
ENTRYPOINT login