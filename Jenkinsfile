#!groovy

pipeline {
  environment {
    imageName = "remusnastasa/my-php"
    buildNumber = "${GIT_REVISION,length=9}"
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
        		dockerImage.push(buildNumber)
        		dockerImage.push('latest')
        	}
    	}
        
    }
    
    stage('Rollout') {
        sh 'kubectl --kubeconfig /etc/kubernetes/kubeconfig --server "https://${KUBE_SERVER}" --token="${SERVICE_ACCOUNT_TOKEN}" rollout restart deployment php'
    }
    
    stage('Cleanup') {
    	steps {
    		sh "docker rmi $imagename:$buildNumber"
        	sh "docker rmi $imagename:latest"
    	}
    }
  }
}
