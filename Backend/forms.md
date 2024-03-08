# Forms

## Create Forms

- Url : `/api/v1/forms`
- Method : `POST`
- Params : `{token}`
- Body :
  ```json
  {
    "name": "Form Name",
    "description": "Form description",
    "type": "private|public",
    "domains": ["gmail.com", "yahoo.com"], // only needed when form type = private
    "expired": "2024-03-30",
    "questions": [
      {
        "question": "Question",
        "description": "vote description",
        "type": "text,number,checkbox,select,textarea",
        "is_required": false,
        "options": "option1,option2" //needed when type = checkbox / select
      },...
    ]
  }
  ```
- Success Reponse
  ```
  Status Code = 200
  ```
  ```json
  {
    "message": "Form successfully created"
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
        "name": "The name field is required"
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

## Get All Forms

- Url : `/api/v1/forms`
- Method : `GET`,
- Params : `{token}`
- Body :-
- Success Response
  ```
  Status Code = 200
  ```
  ```json
  {
    "forms": [
      {
        "id": 1,
        "name": "Form Name",
        "description" : "Form description",
        "respondens_count" : 9,
        "expired": "2024-09-10"
      }, ...
    ]
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

## Get Forms Detail

- Url : `/api/v1/forms/{id}`
- Method : `GET`,
- Params : `{token}`
- Body :-
- Success Response
  ```
  Status Code = 200
  ```
  ```json
  {
    "forms": {
        "name": "Form Name",
        "description" : "Form description",
        "domain": ["gmail.com", "yahoo.com"],
        "expired": "2024-04-12",
        "respondens" : [
          {
            "name": "Your Name",
            "email": "email@gmail.com"
          }, ...
        ],
        "questions": [
          {
            "id": 1,
            "question": "Question",
            "type": "text",
            "description" : "option description"
          }
        ]
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
  - Invalid id
    ```
    Status Code = 404
    ```
    ```json
    {
      "message": "Form not found"
    }
    ```
  - Unaccessable form
    ```
    Status Code = 400
    ```
    ```json
    {
      "message": "You don't have any access to this form"
    }
    ```
