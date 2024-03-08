# Response

## Create Response

- Url : `/api/v1/response`
- Method : `POST`
- Params : `{token}`
- Body :
  ```json
  {
    "form_id": 1,
    "responses": {
      "1": "option1,option2",
      "question_id": "Answer of question"
    }
  }
  ```
- Success Reponse
  ```
  Status Code = 200
  ```
  ```json
  {
    "message": "Answer successfully created"
  }
  ```
- Error Response
  - Field validation failed
    ```
    status code = 400
    ```
    ```json
    {
      "message": "Invalid fields",
      "errors": {
        "responses": "The responses field is required"
      }
    }
    ```
  - User not logged in
    ```
    Status Code = 401
    ```
    ```json
    {
      "message": "Unauthorized user"
    }
    ```
  - User don't have access
    ```
    Status Code = 400
    ```
    ```json
    {
      "message": "You don't have access to answer this form"
    }
    ```
  - Form already expired
    ```
    Status Code = 400
    ```
    ```json
    {
      "message": "Form is already expired"
    }
    ```

## Get Response

- Url : `/api/v1/response`
- Method : `GET`,
- Params : `{token}`
- Body :
  ```json
  {
    "form_id": 1,
    "user_id": 1
  }
  ```
- Success Response
  ```
  Status Code = 200
  ```
  ```json
  {
    "responses": {
      "question 1": "answer 1",
      "question 2": "answer 2"
    }
  }
  ```
- Error Response
  - User not logged in
    ```
    Status Code = 401
    ```
    ```json
    {
      "message": "Unauthorized user"
    }
    ```
  - User don't have access
    ```
    Status Code = 400
    ```
    ```json
    {
      "message": "You don't have access to this form"
    }
    ```
