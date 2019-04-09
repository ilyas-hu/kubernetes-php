#Php Redis Application on Kubernetes

Sample Application that shows how to run Php and Redis Application on kubernetes cluster locally using minikube or on Google Cloud using GKE

### Run the application

to run the application you need docker and kubectl installed in your system, a minikube cluster locally or a GKE cluster


`git clone git@github.com:ilyash00/kubernetes-php.git`

### In minikube

To run in minikube cluster `start minikube` set your local docker client to use minikube docker daemon using `eval $(minikube docker-env)`

Build docker images using 

`docker build -t redis-local -f Dockerfile-redis .`

`docker build -t php-apache-gke -f Dockerfile-php .`

Deploy your Deployment and Services using

`kubectl apply -f redis.yaml`

`kubectl apply -f php-apache.yaml`

Make sure they are running using `kubectl get pods` and `kubectl get services`

Find your service url using

`minikube service php-apache --url`

Check your application using curl

`curl $(minikube service php-apache --url)`

To check redis

`curl $(minikube service php-apache --url)/redis.php`
