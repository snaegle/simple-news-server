# Simple News Server

## Components
- API, realized with Symfony, built with composer
- GUI, realized with Vuejs 3, API-calls with Axios, bundeled with Vite
- Database, realized with MySQL

## Requirements
- nvm (or node >= 16)
- docker
- docker-compose

## Start
- nvm install
- ./start.sh

## Services
- API: http://localhost:8108/news
- GUI: http://localhost:8008
- PHPMyAdmin: http://localhost:8088

## Structure of the frontend
- Main view (./): All available news
- Create new news (./new)
- Edit news: (./edit/&lt;newsid>)
- Delete news: (./delete/&lt;newsid>)

## Culprits during development
- Locate API from frontend: \
  VueJs runs outside of the container, so the route can't be localhost:80, but must use localhost:8108 \
  Configuration in src/services/NewsService.js
- CORS \
  The API must accept CORS-Headers \
  Configuration in symfony/config/packages/nelmio_cors.yaml
- Date input \
  To be universal, the date in the database is stored as Unix timestamp. This is defined as seconds after January 1, 1970.  \
  It is not acceptable from a usability standpoint for users to put in the date directly, so it must be converted into the timestamp whenever the API is read from or written into. \
  In order to do this, the timestamp has to be converted into UTC-string, and in the local format for display to the user.

## Bugs
There is a conversion error about minutes between the display in the datepicker and the actually used date.

## Nice to haves
- A pagination for the overview page
- Unlimited number of characters for the content of the news.
- If no unlimited number is realized, it would be nice to have a warning about how many characters are still available
- If news can be longer, there should be a detail view page, or at least a possibility to hide long content
- The input form is written in several files. This should be converted into a component
- Flash messages should be converted into components
- Integrationtests
