const express = require("express");
const ExpressSwaggerFnGenerator = require("express-swagger-producer");
const routes = require("./routes/index");

const app = express(); 
const router = express.Router();

app.use(express.json());
app.use(express.urlencoded({
    extended:true
}));

routes.forEach((routerFn)=>{
    routerFn(router);
})

app.use("/api", router);

let options = {
    swaggerDefinition: {
        info:{
            description: 'This is a server with basic API features',
            title: 'Simple Server',
            version: '1.0.0'
        },
        host: 'localhost',
        swagger: '2.0', // openapi: '3.0.0'
        basePath: '/api',
        produces:[
            "application/json",
            "application/xml"
        ],
        schemas: ['http','https'],
        securityDefinitions: {
            JWT: {
                type: 'apiKey',
                in: 'header',
                name: 'Authorization',
                description: 'Basic apiKey authorization in the system'
            }
        }
    },
    basedir: __dirname,
    files: ['./routes/**-*.js']
}

const ExpressSwaggerFn = ExpressSwaggerFnGenerator(app);

ExpressSwaggerFn(options)

app.listen(80, () => {
    console.console.log(("EXPRESS SERVER 80. PORTU DINLIYOR"));
})