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
        		dockerImage.push(${GIT_REVISION,length=9})
        		dockerImage.push('latest')
        	}
    	}
        
    }
    
    stage('Rollout') {
        sh 'kubectl --kubeconfig /etc/kubernetes/kubeconfig --server "https://${KUBE_SERVER}" --token="${SERVICE_ACCOUNT_TOKEN}" rollout restart deployment php'
    }
    
    stage('Cleanup') {
    	steps {
    		sh "docker rmi $imagename:${GIT_REVISION,length=9}"
        	sh "docker rmi $imagename:latest"
    	}
    }
  }
}
