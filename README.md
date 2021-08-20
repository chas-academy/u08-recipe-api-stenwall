# U08 Recipe API

School Assignment @ Chas Academy, class FWD20

---

>In this assignment, you will build a backend API for the recipe application [u07](https://github.com/chas-academy/u07-recipe-app-stenwall) and use it in the frontend.

>The functionality to be added is a backend, built as a RESTful API in Laravel, that can manage users and their recipe lists. This API will then be consumed by the application from u07 which now needs to be able to handle user login and CRUD on the user's own recipe lists. API data for the recipes must still be retrieved from an external API.

## Requirements

As a user, you should be able to do the following (same requirements as in u07):

- [x] Be able to get a list of recipe suggestions
- [x] Be able to filter the suggestions of recipes by dish type and allergens/preferences (at least six filters)
- [x] Be able to click on a recipe to see its information (with its own route)
- [x] Be able to save recipes in a list (edit/remove from list) (this part must now be linked to your own API)

### API requirements

- [x] Use JWT based tokens for communication or implementation of Laravel Sanctum for authentication and authorization
- [x] All lists must be linked to a user and may only be changed / read by the same user
- [x] Recipes may only appear once in each list, but the same recipe may appear in several lists
- [x] Data for specific recipes should still be retrieved from an external API

As a user, you should be able to do the following:

- [x] Register an account in the API (create user, log in, log out)
- [x] Save lists of recipes. Each list has as a minimum requirement to contain:
    - [x] title
    - [x] which recipes are included
- [x] Add a list, load a list, change a list and delete a list

### New frontend requirements


- [x] Users should be able to create an account, log in and log out
- [x] Users must be able to perform CRUD on their own recipe lists

## Deployment

The API is deployed on Heroku: [parsley-sage.herokuapp.com](https://parsley-sage.herokuapp.com/)

The frontend is deployed on Netlify: [parsley-and-sage.netlify.app](https://parsley-and-sage.netlify.app/)

## API

The base URL with above deployment is: [parsley-sage.herokuapp.com/api](https://parsley-sage.herokuapp.com/api)

### Model URIs for lists

| Methods | URLs | Actions |
|---|---|---|
| POST | `/lists` | create new list |
| GET | `/lists` | get all lists belonging to auth user |
| PUT | `/lists/:listId` | update given list |
| GET | `/lists/:listId` | get all lists where recipe exists |
| DELETE | `/lists/:listId`| delete given list |
| POST |  `/lists/:listId/recipes` | add new recipe to given list |
| GET | `/lists/:listId/recipes` | get all recipes in given list |
| GET | `/lists/:listId/recipes/:apiId` | check if recipe exists in given list |
| DELETE | `/lists/:listId/recipes/:recipeId` | remove given recipe from given list |

### Model URIs for auth

| Methods | URLs | Actions |
|---|---|---|
| POST | `/auth/register`| create new user |
| POST | `/auth/login` | log in user, create token |
| POST | `/auth/refresh` | refresh token |
| POST | `/auth/logout`| log user out |
| GET | `/auth/user-profile`| get info about auth user |

## Notes

---

This project is made with [Laravel](https://laravel.com/) v8.51.0 (PHP v8.0.1)