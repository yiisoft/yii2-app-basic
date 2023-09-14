# pull official base image
FROM node:16.13.1

# set working directory
WORKDIR /app

# add `/app/node_modules/.bin` to $PATH
ENV PATH /app/node_modules/.bin:$PATH

# install app dependencies

COPY package.json ./
COPY package-lock.json ./
RUN npm install

RUN mkdir node_modules/.cache && chmod -R 777 node_modules/.cache

# add app
COPY . ./

# start app
CMD ["npm", "start"]