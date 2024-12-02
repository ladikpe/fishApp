pipeline {
    agent any

    environment{
        Jenkins_server_ip = ""
    }

    stages{
        stage(build){
            steps{
                script {
                   echo "pull web request" 
                   git branch: 'main', url: 'https://github.com/ladikpe/fishApp.git'
                }

            }
        }
    } 

}