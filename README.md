Copy .env

    cp .env.example .env

Copy frontend .env

    cd frontend
    cp .env.example .env

Start the container

    docker-compose up -d --build

Open

    http://localhost:3000/
