# Authentication

## Register

- Url : `/api/v1/authentication/register`
- Method : `POST`
- Params : -
- Body :
  ```json
  {
    "name": "Your Name",
    "email": "email@mail.com",
    "password": "password",
    "password_confirmation": "password"
  }
  ```
- Success Response

  ```
  Status Code = 200
  ```

  ```json
  {
    "message": "Register success"
  }
  ```

- Error Response
  - Validation Fails
    ```
    Status Code = 400
    ```
    ```json
    {
      "message": "Invalid fields",
      "errors": {
        "email": "Email already exist",
        "password": "The password field confirmation does not match."
      }
    }
    ```

## Login

- Url : `/api/v1/authentication/login`
- Method : `POST`
- Params : -
- Body :
  ```json
  {
    "email": "email@mail.com",
    "password": "password"
  }
  ```
- Success Response
  ```
  Status Code = 200
  ```
  ```json
  {
    "user": {
      "name": "Your Name",
      "email": "email@email.com"
    },
    "token": "{md5_token_by_user_email}"
  }
  ```
- Error Response
  - Incorrect email / password
    ```
    Status Code = 401
    ```
    ```json
    {
      "message": "Email or Password incorrect"
    }
    ```

## Logout

- Url : `/api/v1/authentication/logout`
- Method : `POST`
- Params : -
- Body :
  ```json
  {
    "token": "{md5_token_by_user_email}"
  }
  ```
- Success Response
  ```
  Status Code = 200
  ```
  ```json
  {
    "message": "Logout Success"
  }
  ```
- Error Response
  - User not login
    ```
    Status code = 401
    ```
    ```json
    {
      "message": "Invalid token"
    }
    ```
