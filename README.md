# Scooters

## Installation steps

- Clone the repository
- Move inside the folder
- Run the command
```
docker compose up -d
```

This will set up a PostgreSQL database, a web server for the API and 3 clients that are sending trips to that API.

The possible requests are documented in the requests.http file.

The API should be available in [here](http://localhost)

## Assumptions

1. Don't makes sense to save all the generated events: they just have an historical value and the requested features doesn't mention nothing about that so I consider better to receive an event and do the expected actions with that:
   1.1. If the scooter doesn't exist then let's create it.
2. Update the scooter location.
3. The scooter status is busy until we receive a end_trip event.
