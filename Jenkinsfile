#!groovy

pipeline {
  environment {
    imageName = "remusnastasa/my-php"
    dockerImage = ''
  }
  agent any
  stages {
    stage('Checkout') {
      checkout scm
    }

    stage('Build') {
    	script {
        	dockerImage = docker.build imageName
    	}
    }
    
    stage('Deploy') {
    	script {
        	docker.withRegistry('') {
        		dockerImage.push('latest')
        	}
    	}
        
    }
    
    stage('Rollout') {
        sh 'kubectl --kubeconfig /etc/kubernetes/kubeconfig --server "https://${KUBE_SERVER}" --token="${SERVICE_ACCOUNT_TOKEN}" rollout restart deployment php'
    }
    
    stage('Cleanup') {
        sh "docker rmi $imagename:latest"
    }
  }
}
