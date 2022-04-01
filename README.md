# Annotations Rest API

# Table of Contents
- [Setup](#setup)
    - [XAMPP](#xampp)
- [API Endpoints](#api-endpoints)
- [Database](#database)
    - [Annotations](#annotations)
    - [Annotations_Group](#annotation_group)

## Setup
Open the "inc/config.php" file and fill in the Host Name, Username, Password, and Database Name.

### XAMPP
1) Download this repo and move the directory to the "xampp/htdocs" directory.

2) Change the repo directory name a desired name. 

3) Use the following url format to use the Rest API:
```
 {HostName}/{DesiredName}/index.php/{EndPoint}
```

## API Endpoints

These endpoints allow a user to read and modify the contents of the database.

### GET
`HostName/DesiredName` [/annotations](#get-annotations) <br/>
`HostName/DesiredName` [/annotations/byId](#get-annotationsbyid) <br/>
`HostName/DesiredName` [/annotations/byGroup](#get-annotationsbygroup) <br/>
`HostName/DesiredName` [/annotations/byUrl](#get-annotationsbyurl) <br/>
`HostName/DesiredName` [/groups](#get-groups) <br/>
`HostName/DesiredName` [/groups/byGroupName](#get-groupsbygroupname) <br/>
`HostName/DesiredName` [/help](#get-help) <br/>

### POST
`HostName/DesiredName` [/annotations](#post-annotations) <br/>
`HostName/DesiredName` [/groups](#post-groups) <br/>

### PUT
`HostName/DesiredName` [/annotations/byId](#put-annotationsbyid) <br/>
`HostName/DesiredName` [/groups/byGroupName](#put-groupsbygroupname) <br/>


### GET /annotations
Get all of the annotations in the database.

**Parameters**

No Parameters.            

**Response**
```
// There are no annotations in the table
[]

or

// There are at least one annotation in the table
[
    {
        "id": 1,
        "url": "test/url/1.html",
        "title": "Test Title 1",
        "description": "Test Description 1",
        "description_link": "Test Description Link 1",
        "group_name": "Test Group Name 1",
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
        "annotation_transform": {
            "rotation": {
                "w": 1,
                "x": 2,
                "y": 3,
                "z": 4
            },
            "scale3D": {
                "x": 5,
                "y": 6,
                "z": 7
            },
            "translation": {
                "x": 8,
                "y": 9,
                "z": 10
            }
        },
        "last_updated": "2022-02-02 22:22:22"
    },
    ...
    {
        "id": 5,
        "url": "test/url/5.html.php",
        "title": "Test Title 5",
        "description": "Test Description 5",
        "description_link": "Test Description Link 5",
        "group_name": "Test Group Name 5",
        "camera_location": {
            "x": 9,
            "y": 8,
            "z": 7
        },
        "look_at_point": {
            "x": 6,
            "y": 5,
            "z": 4
        },
        "annotation_transform": {
            "rotation": {
                "w": 10,
                "x": 9,
                "y": 8,
                "z": 7
            },
            "scale3D": {
                "x": 6,
                "y": 5,
                "z": 4
            },
            "translation": {
                "x": 3,
                "y": 2,
                "z": 1
            }
        },
        "last_updated": "2022-05-05 15:55:55"
    }
]

or if an error occured

{
    "error": "An error message"
}
```
___

### GET /annotations/byId
Get the annotation with the given ID.

**Parameters**
| Name | Required | Type | Description |
| ----:|:--------:|:----:|:----------- |
| `id` | required | int  | The id of the annotation to query. |

**Response**
```
// There is no annotation with the given id.
{
    "message": "There is no annotation with the given id"
}

or

// There is an annotation with the given id.
{
    "id": 1,
    "url": "test/url/1.html",
    "title": "Test Title 1",
    "description": "Test Description 1",
    "description_link": "Test Description Link 1",
    "group_name": "Test Group Name 1",
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
    "annotation_transform": {
        "rotation": {
            "w": 1,
            "x": 2,
            "y": 3,
            "z": 4
        },
        "scale3D": {
            "x": 5,
            "y": 6,
            "z": 7
        },
        "translation": {
            "x": 8,
            "y": 9,
            "z": 10
        }
    },
    "last_updated": "2022-02-02 22:22:22"
}

or if an error occured

{
    "error": "An error message"
}
```
___

### GET /annotations/byGroup
Get all the annotations in the given group.

**Parameters**
| Name | Required | Type | Description |
| ----:|:--------:|:----:|:----------- |
| `group_name` | required | string  | The name of the group to query annotations by. |

**Response**
```
// There are no annotation with the given group name.
[]

or

// There is at least one annotation with the given group name.
[
    {
        "id": 1,
        "url": "test/url/1.html",
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
        "annotation_transform": {
            "rotation": {
                "w": 1,
                "x": 2,
                "y": 3,
                "z": 4
            },
            "scale3D": {
                "x": 5,
                "y": 6,
                "z": 7
            },
            "translation": {
                "x": 8,
                "y": 9,
                "z": 10
            }
        },
        "last_updated": "2022-02-02 22:22:22"
    },
    ...
    {
        "id": 5,
        "url": "test/url/5.html",
        "title": "Test Title 5",
        "description": "Test Description 5",
        "description_link": "Test Description Link 5",
        "group_name": "Test Group Name",
        "camera_location": {
            "x": 9,
            "y": 8,
            "z": 7
        },
        "look_at_point": {
            "x": 6,
            "y": 5,
            "z": 4
        },
        "annotation_transform": {
            "rotation": {
                "w": 1,
                "x": 2,
                "y": 3,
                "z": 4
            },
            "scale3D": {
                "x": 5,
                "y": 6,
                "z": 7
            },
            "translation": {
                "x": 8,
                "y": 9,
                "z": 10
            }
        },
        "last_updated": "2022-05-05 15:55:55"
    }
]

or if an error occured

{
    "error": "An error message"
}
```
___

### GET /annotations/byUrl
Get all the annotations in the given url.

**Parameters**
| Name | Required | Type | Description |
| ----:|:--------:|:----:| ----------- |
| `url` | required | string  | The url to query annotations by. |

**Response**
```
// There are no annotations with the given url.
[]

or

// There is at least one annotation with the given url.
[
    {
        "id": 1,
        "url": "test/url.html",
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
        "annotation_transform": {
            "rotation": {
                "w": 1,
                "x": 2,
                "y": 3,
                "z": 4
            },
            "scale3D": {
                "x": 5,
                "y": 6,
                "z": 7
            },
            "translation": {
                "x": 8,
                "y": 9,
                "z": 10
            }
        },
        "last_updated": "2022-02-02 22:22:22"
    },
    ...
    {
        "id": 5,
        "url": "test/url.html",
        "title": "Test Title 5",
        "description": "Test Description 5",
        "description_link": "Test Description Link 5",
        "group_name": "Test Group Name",
        "camera_location": {
            "x": 9,
            "y": 8,
            "z": 7
        },
        "look_at_point": {
            "x": 6,
            "y": 5,
            "z": 4
        },
        "annotation_transform": {
            "rotation": {
                "w": 1,
                "x": 2,
                "y": 3,
                "z": 4
            },
            "scale3D": {
                "x": 5,
                "y": 6,
                "z": 7
            },
            "translation": {
                "x": 8,
                "y": 9,
                "z": 10
            }
        },
        "last_updated": "2022-05-05 15:55:55"
    }
]

or if an error occured

{
    "error": "An error message"
}
```
___

### GET /groups
Get all of the groups in the database.

**Parameters**
| Name | Required | Type | Description |
| ----:|:--------:|:----:| ----------- |
| `group_name` | required | string  | The name of the group to query. |

**Response**
```
// There are no groups.
[]

or

// There is at least one group in the table.
[
    {
        "group_name": "Group 1",
        "scene_settings": "{\"setting 1\": \"value 1\"}"
    },
    ...
    {
        "group_name": "Group 2",
        "scene_settings": "{ \"setting 2\": \"value 2\" }"
    }
]

or if an error occured

{
    "error": "An error message"
}
```
___

### GET /groups/byGroupName
Get the group with the given group name.

**Parameters**
| Name | Required | Type | Description |
| ----:|:--------:|:----:| ----------- |
| `group_name` | required | string  | The name of the group to query. |

**Response**
```
// There is no group with the given name.
{
    "message": "There is no group with the given name."
}

or

// There is a group with the given group name
{
    "group_name": "Group 1",
    "scene_settings": "{\"setting 1\": \"value 1\"}"
}

or if an error occured

{
    "error": "An error message"
}
```
___

### GET /help
Get help on the given endpoint. Get the avaiable endpoints if no endpoint is given.

**Parameters**
| Name | Required | Type | Description |
| ----:|:--------:|:----:| ----------- |
| `endpoint` | optional | string  | The endpoint to get help for. |

**Response**
```
// No endpoint is provided
Valid Endpoints = ["annotations", "annotations/byId", "annotations/byGroup","annotations/buUrl", "groups", "groups/byGroupName"]

For more detailed documentation read the README: https://github.com/MatthewDZane/AnthropologyAnnotationsAPI/blob/main/README.md

or

// A valid endpoint is provided
GET - [Get verb description for endpoint]
POST - [Post verb description for endpoint]
PUT - [Put verb description for endpoint]

For more detailed documentation read the README: https: //github.com/MatthewDZane/AnthropologyAnnotationsAPI/blob/main/README.md

or if an invalid endpoint is provided

{
    "error": "endpoint (invalid_endpoint) is not valid."
}
```
___
### POST /annotations
Inserts a new annotation record into the database.

**Body**
| Name | Required | Type | Description |
| ----:|:--------:|:----:| ----------- |
|     `url`                 | required | string | The url that the annotation is    located. |
|     `title`               | required | string | The title of the annotation.  |
|     `description`         | required | string | The description of the annotation. |
|     `description_link`    | required | string | The description link of the annotation. |
|     `group_name`          | required | string | The name of the group that the annotation is associated with. |
|     `camera_location`     | required | json   | A json containing 3D coordinates of the annotation camera location.  <br/><br/> Format: \{"x": 1,"y": 2,"z": 3\}   |
|     `look_at_point`       | required | json   | A json containing 3D coordinates of the location that the annotation is looking at.  <br/><br/> Format: \{"x": 1,"y": 2,"z": 3\}   |
|     `annotation_transform` | required | json   | A json containing a "rotation" struct (Quaternion), "scale3D" struct (Point), "translation" struct (Point).  <br/><br/> Format: \{ "rotation": { "w": 0, "x": 1,"y": 2,"z": 3}, "scale3D": {"x": 1, "y": 2,"z": 3}, "translation": {"x": 1, "y": 2, "z": 3 } \}   |

Example Body:
```
{
    "url": "Test Url",
    "title": "Test Title",
    "description": "Test Description",
    "description_link": "Test Description Link",
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
    "annotation_transform": {
        "rotation": {
            "w": 1,
            "x": 2,
            "y": 3,
            "z": 4
        },
        "scale3D": {
            "x": 5,
            "y": 6,
            "z": 7
        },
        "translation": {
            "x": 8,
            "y": 9,
            "z": 10
        }
    }
}

```


**Response**

```
// The annotation record was inserted successfully.
{
    "message": "The annotation was inserted successfully.",
    "inserted_annotation": {
        "id": 1,
        "url": "Test Url",
        "title": "Test Title",
        "description": "Test Description",
        "description_link": "Test Description Link",
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
        "annotation_transform": {
            "rotation": {
                "w": 1,
                "x": 2,
                "y": 3,
                "z": 4
            },
            "scale3D": {
                "x": 5,
                "y": 6,
                "z": 7
            },
            "translation": {
                "x": 8,
                "y": 9,
                "z": 10
            }
        },
        "last_updated": "2022-02-13 13:19:08"
    }
}

or if an error occured

{
    "error": "An error message"
}
```
___

### POST /groups
Inserts a new group record into the database.

**Body**
| Name | Required | Type | Description |
| ----:|:--------:|:----:| ----------- |
| `group_name`     | required | string | The name of the group. |
| `scene_settings` | required | string | The setting of the scene associated with the group. <br/><br/> This string is to be parsed as a json by the front end. It is assumed that the frontend will generate a string in the form a json, so it is unnecessary to reformat this string value. <br/><br/> There will typically be backslashes to preserve the inner quotation characters. Ex: "{\\"setting\\": \\"value\\"}"|

Example Body:
```
{
    "group_name": "New Group",
    "scene_settings": "{\"setting\\": \"value\"}"
}

```

**Response**

```
// The annotation record was inserted successfully.
{
    "message": "The group was inserted successfully.",
    "inserted_group": {
        "group_name": "New Group",
        "scene_settings": "{\"setting\\": \"value\"}"
    }
}

or if an error occured

{
    "error": "An error message"
}
```
___

### PUT /annotations/byId
Updates the given group record with the given group data.

**Body**
| Name | Required |  Type | Description                        
| -------------:|:--------:|:-------:| --------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
|     `id`                  | required | string | The ID of the annotation to update. |
|     `url`                 | required | string | The url that the annotation is    located. |
|     `title`               | required | string | The title of the annotation.  |
|     `description`         | required | string | The description of the annotation. |
|     `description_link`    | required | string | The description link of the annotation. |
|     `group_name`          | required | string | The name of the group that the annotation is associated with. |
|     `camera_location`     | required | json   | A json containing 3D coordinates of the annotation camera location.  <br/><br/> Format: \{"x": 1,"y": 2,"z": 3\}   |
|     `look_at_point`       | required | json   | A json containing 3D coordinates of the location that the annotation is looking at.  <br/><br/> Format: \{"x": 1,"y": 2,"z": 3\}   |
|     `annotation_transform` | required | json   | A json containing a "rotation" struct (Quaternion), "scale3D" struct (Point), "translation" struct (Point).  <br/><br/> Format: \{ "rotation": { "w": 0, "x": 1,"y": 2,"z": 3}, "scale3D": {"x": 1, "y": 2,"z": 3}, "translation": {"x": 1, "y": 2, "z": 3 } \}   |

Example Body:
```
{
    "id" : 1,
    "url": "Test Url",
    "title": "Test Title",
    "description": "Test Description",
    "description_link": "Test Description Link",
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
    "annotation_transform": {
        "rotation": {
            "w": 1,
            "x": 2,
            "y": 3,
            "z": 4
        },
        "scale3D": {
            "x": 5,
            "y": 6,
            "z": 7
        }
        "translation": {
            "x": 8,
            "y": 9,
            "z": 10
        }
    }
}
```

**Response**
```
// The annotation record was inserted successfully.
{
    "message": "The annotation was updated successfully.",
    "inserted_annotation": {
        "id": 1,
        "url": "Test Url",
        "title": "Test Title",
        "description": "Test Description",
        "description_link": "Test Description Link",
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
        "annotation_transform": {
            "rotation": {
                "w": 1,
                "x": 2,
                "y": 3,
                "z": 4
            },
            "scale3D": {
                "x": 5,
                "y": 6,
                "z": 7
            },
            "translation": {
                "x": 8,
                "y": 9,
                "z": 10
            }
        },
        "last_updated": "2022-02-13 13:19:08"
    }
}

or if an error occured

{
    "error": "An error message"
}
```
___

### PUT /groups/byGroupName
Updates the annotation record with the given ID with the given annotation data.

**Body**
| Name | Required | Type | Description |
| -------------:|:--------:|:-------:| --------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| `current_group_name` | required | string | The current name of the group to update. |
| `group_name`         | required | string | The new name of the group. |
| `scene_settings`     | required | string | The new settings of the scene associated with the group. <br/><br/> This string is to be parsed as a json by the front end. It is assumed that the frontend will generate a string in the form a json, so it is unnecessary to reformat this string value. <br/><br/> There will typically be backslashes to preserve the inner quotation characters. Ex: "{\\"setting\\": \\"value\\"}"|

Example Body:
```
{
    "current_group_name": "Old Group",
    "group": {
        "group_name": "Updated Group",
        "scene_settings": "{\"setting\\": \"value\"}"
    }
}
```


**Response**

```
// The group record was updated successfully.
{
    "message": "The group was updated successfully.",
    "updated_group": {
        "group_name": "Updated Group",
        "scene_settings": "{\"setting\\": \"value\"}"
    }
}

or if an error occured

{
    "error": "An error message"
}
```
___
