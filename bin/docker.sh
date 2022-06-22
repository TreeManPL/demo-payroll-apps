#!/bin/bash

set -e

cmd_up()
{
    $COMPOSE up --detach --no-recreate
}

cmd_down()
{
    $COMPOSE down --remove-orphans
}

cmd_stop()
{
    $COMPOSE stop
}

cmd_ps()
{
    printf "\n"
    $COMPOSE ps
    printf "\n"
}

cmd_sh()
{
    container_name="_${1}"
    container_id=$(docker ps --filter name="$container_name" --quiet)
    if [ -z "$container_id" ]; then
        echo "container $container_name not found" 1>&2
    else
        if [ -n "${2}" ]; then
            docker exec -it -u ${2} ${container_id} sh
        else
            docker exec -it ${container_id} sh
        fi
    fi
}

usage()
{
cat << EOF
USAGE:
    $0 [-h] [-e N] COMMAND

COMMANDS:
    up                          docker-compose up
    down                        docker-compose down
    stop                        docker-compose stop
    ps                          docker-compose ps
    sh <container_name>         run shell in the container
    root <container_name>       run shell in the container as root
EOF

cat << EOF
OPTIONS:
    -h  Help

EOF
}

COMPOSE_CONFIG_FILE="docker/docker-compose.yaml"
test ! -f "$COMPOSE_CONFIG_FILE" && echo "$COMPOSE_CONFIG_FILE not found" 1>&2 && exit 1
COMPOSE='docker-compose --file='"$COMPOSE_CONFIG_FILE"


CMD=''
EXAMPLE=0
while getopts "he:" OPTNAME; do
    case "$OPTNAME" in
        e) EXAMPLE="$OPTARG"; ;;
        h|*) usage; exit 0; ;;
    esac
done
shift $((OPTIND-1))

case "$1" in
    "up")               cmd_up; ;;
    "down")             cmd_down; ;;
    "stop")             cmd_stop; ;;
    "ps")               cmd_ps; ;;
    "sh")               cmd_sh "${2}"; ;;
    "root")             cmd_sh "${2}" root; ;;
    *) cmd_try_run_cmd "$@"; exit 1; ;;
esac
