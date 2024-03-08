# Question

## Create Question

- Url : `/api/v1/questions`
- Method : `POST`
- Params : `{token}`
- Body :
  ```json
  {
    "question": "Question",
    "description": "vote description",
    "type": "text,number,checkbox,select,textarea",
    "is_required": false,
    "options": "option1,option2" //needed when type = checkbox / select
  }
  ```
- Success Reponse
  ```
  Status Code = 200
  ```
  ```json
  {
    "message": "question successfully created"
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
        "question": "The question field is required"
      }
    }
    ```
  - User don't have access

    ```
    Status Code = 400
    ```

    ```json
    {
      "message": "You don't have access to create question in this forms"
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

## Get Question

- Url : `/api/v1/questions`
- Method : `GET`,
- Params : `{token}`
- Body :
  ```json
  {
    "form_id": 1
  }
  ```
- Success Response
  ```
  Status Code = 200
  ```
  ```json
  {
    "questions": [
      {
        "id": 2,
        "questions": "question",
        "description" : "vote description",
        "type": "select",
        "is_required": true,
        "options": []
      }, ...
    ]
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
