# U08 Recipe API

School Assignment @ Chas Academy, class FWD20

---

>In this assignment, you will build a backend API for the recipe application [u07](https://github.com/chas-academy/u07-recipe-app-stenwall) and use it in the frontend part.

>The functionality to be added is a backend, built as a RESTful API in Laravel, that can manage users and their recipe lists. This API will then be consumed by the application from u07 which now needs to be able to handle user login and CRUD on the user's own recipe lists. API data for the recipes must still be retrieved from an external API.

## Requirements

As a user, you should be able to do the following (same requirements as in u07):

- [x] Be able to get a list of recipe suggestions
- [x] Be able to filter the suggestions of recipes by dish type and allergens/preferences (at least six filters)
- [x] Be able to click on a recipe to see its information (with its own route)
- [x] Be able to save recipes in a list (edit/remove from list) (this part must now be linked to your own API)

### API requirements

- [x] Use JWT based tokens for communication or implementation of Laravel Sanctum for authentication and authorization
- [ ] All lists must be linked to a user and may only be changed / read by the same user
- [x] Recipes may only appear once in each list, but the same recipe may appear in several lists
- [x] Data for specific recipes should still be retrieved from an external API

As a user, you should be able to do the following:

- [x] Register an account in the API (create user, log in, log out)
- [ ] Save lists of recipes. Each list has as a minimum requirement to contain:
    - [ ] title
    - [ ] which recipes are included
- [ ] Add a list, load a list, change a list and delete a list

### New frontend requirements


- [ ] Users should be able to create an account, log in and log out
- [ ] Users must be able to perform CRUD on their own recipe lists

## Deployment

The frontend is deployed on Netlify: [parsley-and-sage.netlify.app](https://parsley-and-sage.netlify.app/)

## Notes

### Design

### Other notes


---
