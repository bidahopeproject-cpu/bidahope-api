# Build the Docker image
docker build -t bidahope-api .

# Run locally on port 10000
docker run -d \
  -p 10000:10000 \
  -e APP_ENV=production \
  -e APP_DEBUG=false \
  -e LOG_CHANNEL=stderr \
  bidahope-api