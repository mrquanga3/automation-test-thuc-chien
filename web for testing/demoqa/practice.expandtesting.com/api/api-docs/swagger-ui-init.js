
window.onload = function() {
  // Build a system
  var url = window.location.search.match(/url=([^&]+)/);
  if (url && url.length > 1) {
    url = decodeURIComponent(url[1]);
  } else {
    url = window.location.origin;
  }
  var options = {
  "swaggerDoc": {
    "openapi": "3.0.0",
    "info": {
      "title": "Practice API",
      "version": "1.0.0",
      "description": "This API is intended for practice and demonstration purposes. It offers\nutility endpoints including geolocation, health check, random value generation,\nand more.\n"
    },
    "servers": [
      {
        "url": "https://practice.expandtesting.com/api"
      }
    ],
    "paths": {
      "/health-check": {
        "get": {
          "tags": [
            "Health-Check"
          ],
          "operationId": "healthCheck",
          "summary": "Get health status of the API",
          "description": "Check if the server is running.",
          "responses": {
            "200": {
              "description": "Health check successful",
              "content": {
                "application/json": {
                  "schema": {
                    "type": "object",
                    "properties": {
                      "success": {
                        "type": "boolean",
                        "example": true
                      },
                      "status": {
                        "type": "string",
                        "example": "UP"
                      },
                      "message": {
                        "type": "string",
                        "example": "API is up!"
                      }
                    }
                  }
                }
              }
            }
          }
        }
      },
      "/get-city": {
        "get": {
          "tags": [
            "Geo"
          ],
          "summary": "Get city from latitude and longitude",
          "operationId": "getCity",
          "parameters": [
            {
              "name": "lat",
              "in": "query",
              "required": true,
              "schema": {
                "type": "number"
              }
            },
            {
              "name": "lon",
              "in": "query",
              "required": true,
              "schema": {
                "type": "number"
              }
            }
          ],
          "responses": {
            "200": {
              "description": "City found",
              "content": {
                "application/json": {
                  "schema": {
                    "type": "object",
                    "properties": {
                      "status": {
                        "type": "string",
                        "example": "success"
                      },
                      "city": {
                        "type": "string",
                        "example": "Paris"
                      }
                    }
                  }
                }
              }
            }
          }
        }
      },
      "/random-color": {
        "get": {
          "tags": [
            "Random"
          ],
          "summary": "Generate a random color",
          "operationId": "randomColor",
          "responses": {
            "200": {
              "description": "Random hex color",
              "content": {
                "application/json": {
                  "schema": {
                    "type": "object",
                    "properties": {
                      "color": {
                        "type": "string",
                        "example": "#a1b2c3"
                      }
                    }
                  }
                }
              }
            }
          }
        }
      },
      "/random-number": {
        "get": {
          "tags": [
            "Random"
          ],
          "summary": "Generate a random number",
          "operationId": "randomNumber",
          "parameters": [
            {
              "name": "min",
              "in": "query",
              "schema": {
                "type": "integer",
                "default": 1
              }
            },
            {
              "name": "max",
              "in": "query",
              "schema": {
                "type": "integer",
                "default": 100
              }
            }
          ],
          "responses": {
            "200": {
              "description": "Random number",
              "content": {
                "application/json": {
                  "schema": {
                    "type": "object",
                    "properties": {
                      "number": {
                        "type": "integer",
                        "example": 42
                      }
                    }
                  }
                }
              }
            }
          }
        }
      },
      "/echo": {
        "post": {
          "tags": [
            "Utility"
          ],
          "summary": "Echo message back",
          "operationId": "echoMessage",
          "requestBody": {
            "required": true,
            "content": {
              "application/json": {
                "schema": {
                  "type": "object",
                  "properties": {
                    "name": {
                      "type": "string",
                      "example": "Tawfik"
                    }
                  }
                }
              },
              "application/xml": {
                "schema": {
                  "type": "object",
                  "properties": {
                    "name": {
                      "type": "string",
                      "example": "Tawfik"
                    }
                  },
                  "xml": {
                    "name": "Post_request"
                  }
                }
              }
            }
          },
          "responses": {
            "200": {
              "description": "Echoed message",
              "content": {
                "application/json": {
                  "schema": {
                    "type": "object",
                    "properties": {
                      "echoed": {
                        "type": "string",
                        "example": "Hello"
                      }
                    }
                  }
                },
                "application/xml": {
                  "schema": {
                    "type": "object",
                    "properties": {
                      "echoed": {
                        "type": "string",
                        "example": "Hello"
                      }
                    },
                    "xml": {
                      "name": "Post_200_response"
                    }
                  }
                }
              }
            }
          }
        }
      },
      "/add": {
        "get": {
          "tags": [
            "Math"
          ],
          "summary": "Add two numbers",
          "operationId": "addNumbers",
          "parameters": [
            {
              "name": "a",
              "in": "query",
              "required": true,
              "schema": {
                "type": "number"
              }
            },
            {
              "name": "b",
              "in": "query",
              "required": true,
              "schema": {
                "type": "number"
              }
            }
          ],
          "responses": {
            "200": {
              "description": "Sum calculated",
              "content": {
                "application/json": {
                  "schema": {
                    "type": "object",
                    "properties": {
                      "result": {
                        "type": "number",
                        "example": 7.5
                      }
                    }
                  }
                }
              }
            }
          }
        }
      },
      "/time": {
        "get": {
          "tags": [
            "Utility"
          ],
          "summary": "Get current server time",
          "operationId": "getTime",
          "responses": {
            "200": {
              "description": "ISO timestamp",
              "content": {
                "application/json": {
                  "schema": {
                    "type": "object",
                    "properties": {
                      "time": {
                        "type": "string",
                        "format": "date-time",
                        "example": "2025-07-06T15:00:00.000Z"
                      }
                    }
                  }
                }
              }
            }
          }
        }
      },
      "/cars": {
        "get": {
          "tags": [
            "Cars"
          ],
          "operationId": "getCars",
          "summary": "Get list of cars",
          "description": "Retrieve a list of available cars with their details such as id,\nname, price, and image URL.\n",
          "responses": {
            "200": {
              "description": "A JSON array of cars",
              "content": {
                "application/json": {
                  "schema": {
                    "type": "object",
                    "properties": {
                      "status": {
                        "type": "string",
                        "example": "success"
                      },
                      "cars": {
                        "type": "array",
                        "items": {
                          "type": "object",
                          "properties": {
                            "id": {
                              "type": "integer",
                              "example": 1
                            },
                            "name": {
                              "type": "string",
                              "example": "VW Golf"
                            },
                            "price": {
                              "type": "string",
                              "example": "€25,000"
                            },
                            "image": {
                              "type": "string",
                              "example": "/images/golf.jpg"
                            }
                          }
                        }
                      }
                    }
                  }
                }
              }
            }
          }
        }
      },
      "/myip": {
        "get": {
          "tags": [
            "IP"
          ],
          "operationId": "myIpInfo",
          "summary": "Get your public IP and location",
          "description": "Get your public IP and geolocation info",
          "responses": {
            "200": {
              "description": "IP information",
              "content": {
                "application/json": {
                  "schema": {
                    "type": "object",
                    "properties": {
                      "ip": {
                        "type": "string",
                        "example": "8.8.8.8"
                      },
                      "city": {
                        "type": "string",
                        "example": "New York"
                      },
                      "country": {
                        "type": "string",
                        "example": "US"
                      },
                      "timezone": {
                        "type": "string",
                        "example": "America/New_York"
                      }
                    }
                  }
                }
              }
            }
          }
        }
      },
      "/location-details": {
        "get": {
          "tags": [
            "Geo"
          ],
          "summary": "Get location details from coordinates",
          "operationId": "getLocationDetails",
          "parameters": [
            {
              "name": "latitude",
              "in": "query",
              "required": true,
              "schema": {
                "type": "number"
              }
            },
            {
              "name": "longitude",
              "in": "query",
              "required": true,
              "schema": {
                "type": "number"
              }
            }
          ],
          "responses": {
            "200": {
              "description": "Matching country details",
              "content": {
                "application/json": {
                  "schema": {
                    "type": "object",
                    "properties": {
                      "location_details": {
                        "type": "object",
                        "properties": {
                          "name": {
                            "type": "string",
                            "example": "France"
                          },
                          "code": {
                            "type": "string",
                            "example": "FR"
                          }
                        }
                      }
                    }
                  }
                }
              }
            },
            "404": {
              "description": "No match found"
            }
          }
        }
      },
      "/currency-convert": {
        "get": {
          "summary": "Convert amount between currencies",
          "tags": [
            "Currency"
          ],
          "description": "Converts a given amount from one currency to another using example rates.",
          "parameters": [
            {
              "name": "from",
              "in": "query",
              "required": true,
              "schema": {
                "type": "string",
                "example": "USD"
              }
            },
            {
              "name": "to",
              "in": "query",
              "required": true,
              "schema": {
                "type": "string",
                "example": "EUR"
              }
            },
            {
              "name": "amount",
              "in": "query",
              "required": true,
              "schema": {
                "type": "number",
                "example": 100
              }
            }
          ],
          "responses": {
            "200": {
              "description": "Conversion successful",
              "content": {
                "application/json": {
                  "schema": {
                    "type": "object",
                    "properties": {
                      "from": {
                        "type": "string",
                        "example": "USD"
                      },
                      "to": {
                        "type": "string",
                        "example": "EUR"
                      },
                      "rate": {
                        "type": "number",
                        "example": 0.85
                      },
                      "amount": {
                        "type": "number",
                        "example": 100
                      },
                      "converted": {
                        "type": "number",
                        "example": 85
                      }
                    }
                  }
                }
              }
            },
            "400": {
              "description": "Invalid parameters"
            },
            "500": {
              "description": "Server error"
            }
          }
        }
      },
      "/phone-code/{countryCode}": {
        "get": {
          "tags": [
            "Phone"
          ],
          "summary": "Get phone code by country short name",
          "operationId": "getPhoneCode",
          "parameters": [
            {
              "name": "countryCode",
              "in": "path",
              "required": true,
              "schema": {
                "type": "string",
                "example": "FR"
              }
            }
          ],
          "responses": {
            "200": {
              "description": "Phone code found",
              "content": {
                "application/json": {
                  "schema": {
                    "type": "object",
                    "properties": {
                      "status": {
                        "type": "string",
                        "example": "success"
                      },
                      "countryCode": {
                        "type": "string",
                        "example": "FR"
                      },
                      "phoneCode": {
                        "type": "string",
                        "example": "+33"
                      }
                    }
                  }
                }
              }
            },
            "404": {
              "description": "Country code not found",
              "content": {
                "application/json": {
                  "schema": {
                    "type": "object",
                    "properties": {
                      "status": {
                        "type": "string",
                        "example": "error"
                      },
                      "message": {
                        "type": "string",
                        "example": "Country code not found"
                      }
                    }
                  }
                }
              }
            }
          }
        }
      }
    }
  },
  "customOptions": {},
  "swaggerUrl": {}
};
  url = options.swaggerUrl || url
  var urls = options.swaggerUrls
  var customOptions = options.customOptions
  var spec1 = options.swaggerDoc
  var swaggerOptions = {
    spec: spec1,
    url: url,
    urls: urls,
    dom_id: '#swagger-ui',
    deepLinking: true,
    presets: [
      SwaggerUIBundle.presets.apis,
      SwaggerUIStandalonePreset
    ],
    plugins: [
      SwaggerUIBundle.plugins.DownloadUrl
    ],
    layout: "StandaloneLayout"
  }
  for (var attrname in customOptions) {
    swaggerOptions[attrname] = customOptions[attrname];
  }
  var ui = SwaggerUIBundle(swaggerOptions)

  if (customOptions.oauth) {
    ui.initOAuth(customOptions.oauth)
  }

  if (customOptions.preauthorizeApiKey) {
    const key = customOptions.preauthorizeApiKey.authDefinitionKey;
    const value = customOptions.preauthorizeApiKey.apiKeyValue;
    if (!!key && !!value) {
      const pid = setInterval(() => {
        const authorized = ui.preauthorizeApiKey(key, value);
        if(!!authorized) clearInterval(pid);
      }, 500)

    }
  }

  if (customOptions.authAction) {
    ui.authActions.authorize(customOptions.authAction)
  }

  window.ui = ui
}
