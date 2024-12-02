Pipeline {
    Agent any

    Environment{
        Jenkins_server_ip = ""
    }

    Stages{
        Stage(build){
            Steps{
                script {
                   echo "pull web request" 
                   git branch: 'main', url: 'https://github.com/ladikpe/fishApp.git'
                }

            }
        }
    }

}