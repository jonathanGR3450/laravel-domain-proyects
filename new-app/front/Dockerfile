# Base image
FROM node:18.14.1-alpine as build

RUN mkdir /app
WORKDIR /app

RUN npm install -g @angular/cli@13

COPY package.json package-lock.json ./
RUN npm ci

COPY . .
CMD ["ng", "serve", "--host", "0.0.0.0"]
