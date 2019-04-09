##Php Redis Application on Kubernetes

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

### In Cloud GKE

Connect your kubectl client to your cluster using

`gcloud container clusters get-credentials CLUSTER_NAME --zone CLUSTER_ZONE --project PROJECT_ID`

Build your Docker images and push it to any container registry

`docker build -t php-apache-gke:latest -f Dockerfile-php .`

`docker tag IMAGE_ID DOCKER_HUB_USERNAME/php-apache-gke:latest`

`docker push DOCKER_HUB_USERNAME/php-apache-gke:latest`

`docker build -t redis-local:latest -f Dockerfile-redis .`

`docker tag IMAGE_ID DOCKER_HUB_USERNAME/redis-local:latest`

`docker push DOCKER_HUB_USERNAME/redis-local:latest`

Now we have pushed our image to dockerhub, you can use any other container registry like google cloud container registry.

Create a configmap in your cluster to store your insatance connection details using

`kubectl create configmap redishost --from-literal=REDIS_HOST=redis --from-literal=REDIS_PORT=6379`

One final change before deployment, Change image in `php-apache.yaml` and `redis.yaml` to the image you push to the registry, remove line imagePullPolicy: Never and change Service type for `php-apache` from NodePort to LoadBalancer

Now you can Deploy your deployment and Service using 

`kubectl apply -f php-apache.yaml`

`kubectl apply -f redis.yaml`

To test Deployment use `kubectl get pods` it will show your pod running

To access your application using the LoadBalancer run `kubectl get services` it will give EXTERNAL-IP adderess of you service then you will be able to access your application at that `IP_ADDRESS` and to test redis connection go to `IP_ADDRESS/redis.php`.

### Cloud Memorystore

If you want to use Cloud Memorystore instead of redis container don't deploy `redis.yaml`, instead create a cloud memorystore instance in the same region where your cluster is and change your REDIS_HOST in configmap

`kubectl create configmap redishost --from-literal=REDIS_HOST=REDIS_INSTACE_IP --from-literal=REDIS_PORT=6379`

For this to work your cluster must has IP_ALIAS enable, and, cluster and instance must be in the same region.