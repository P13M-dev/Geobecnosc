@echo off
cd Docker
docker compose up --build -d
echo press to close
pause
docker compose down