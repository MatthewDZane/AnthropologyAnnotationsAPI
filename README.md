# Annotations Rest API

# Table of Contents
- [Setup](#setup)
    - [XAMPP](#xampp)
- [Endpoints](#endpoints)

## Setup
Open the "inc/config.php" file and fill in the Host Name, Username, Password, and Database Name.

### XAMPP
1) Download this repo and move the directory to the "xampp/htdocs" directory.

2) Change the repo directory name a desired name. 

3) Use the following url format to use the Rest API:
```
 {HostName}/{DesiredName}/index.php/{EndPoint}
```

## Endpoints
- annotations  
    - GET
        - Returns a list of all the annotations.
    - POST
        - Inserts the given annotation into the database
        - Example Request Body
            ```
            {
                "url": "Test Url",
                "title": "Test Title 1",
                "description": "Test Description 1",
                "description_link": "Test Description Link 1",
                "group_name": "Test Group Name",
                "camera_location": {
                    "x": 1,
                    "y": 2,
                    "z": 3
                },
                "look_at_point": {
                    "x": 4,
                    "y": 5,
                    "z": 6
                },
                "annotation_location": {
                    "x": 7,
                    "y": 8,
                    "z": 9
                }
            }
            ```
- annotations/groups  
    - GET
        - Returns a list of all the groups.
    - POST
        - Inserts the given group into the database.
        - Example Request Body
            ```
            {
                "group_name": "New Group",
                "scene_settings": "{\"setting\": \"something\"}"
            }
            ```
    - PUT
        - Updates the group which has the given current group name with the given group data.
        - Example Request Body
            ```
            {
                "current_group_name": "",
                "group": {
                    "group_name": "Updated Group",
                    "scene_settings": "{ \"setting\": \"something\" }"
                }
            }
            ```
- annotations/byId    
    - GET
        - Returns a single annotation with the given ID.
        - Requires id parameter.
    - PUT
        - Updates the the annotation which has the given ID with the rest of the annotation data.
        - Example Request Body
            ```
            {
                "id": 1,
                "url": "Updated Url",
                "title": "Updated Title",
                "description": "Updated Description",
                "description_link": "Updated Description Link",
                "group_name": "Updated Group Name",
                "camera_location": {
                    "x": 11,
                    "y": 22,
                    "z": 33
                },
                "look_at_point": {
                    "x": 44,
                    "y": 55,
                    "z": 66
                },
                "annotation_location": {
                    "x": 77,
                    "y": 88,
                    "z": 99
                }
            }
            ```
- annotations/byGroup 
    - GET
        - Returns a list of annotations which have the given group name.
        - Requires group_name parameter.
- annotations/byUrl   
    - GET
        - Returns a list of annotations which have the given url.
        - Requires url parameter.

