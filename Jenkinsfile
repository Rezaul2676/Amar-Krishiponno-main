pipeline {
    agent any

    triggers {
        // GitHub can't reach a private IP, so poll for new commits
        pollSCM('H/2 * * * *')
    }

    environment {
        APP_DIR = '/var/www/amar-krishiponno'
    }

    options {
        timestamps()
        buildDiscarder(logRotator(numToKeepStr: '10'))
    }

    stages {
        stage('Checkout') {
            steps {
                checkout scm
            }
        }

        stage('Install dependencies') {
            steps {
                sh 'composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader'
            }
        }

        stage('Deploy files') {
            steps {
                // .env, storage and bootstrap/cache stay untouched on the server
                sh '''
                    rsync -rlt --delete \
                        --exclude='.git' \
                        --exclude='.env' \
                        --exclude='storage' \
                        --exclude='bootstrap/cache' \
                        ./ ${APP_DIR}/
                '''
            }
        }

        stage('Post-deploy') {
            steps {
                sh '''
                    cd ${APP_DIR}
                    sudo -u apache /usr/bin/php artisan migrate --force
                    sudo -u apache /usr/bin/php artisan config:cache
                    sudo -u apache /usr/bin/php artisan view:clear
                    sudo /usr/bin/systemctl reload php-fpm
                '''
            }
        }
    }

    post {
        success { echo 'Deployed to http://192.168.151.243/' }
        failure { echo 'Deploy failed - check the console output above.' }
    }
}
