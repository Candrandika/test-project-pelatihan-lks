# Question

## Get Detail Question

- Url : `/api/v1/questions/{id}`
- Method : `GET`,
- Params : `{token}`
- Body : -
- Success Response
  ```
  Status Code = 200
  ```
  ```json
  {
    "questions": {
      "id": 2,
      "questions": "question",
      "description": "vote description",
      "type": "select",
      "is_required": true,
      "options": []
    },
    "responses": {
      "email@gmail.com": "answer 1",
      "email2@gmail.com": "answer 2"
    }
  }
  ```
- Error Response

  - User don't have access

    ```
    Status Code = 400
    ```

    ```json
    {
      "message": "You don't have access to this form"
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
