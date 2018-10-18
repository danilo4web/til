
# include it at the end of .bashrc

function parse_git_branch {
git branch --no-color 2> /dev/null | sed -e '/^[^*]/d' -e 's/* \(.*\)/(\1)/'
}

function proml {
local WHITE="\[\033[1;37m\]"
local BLACK="\[\033[0;30m\]"
local BLUE="\[\033[0;34m\]"
local LIGHT_BLUE="\[\033[1;34m\]"
local CYAN="\[\033[0;36m\]"
local RED="\[\033[0;31m\]"
local LIGHT_RED="\[\033[1;31m\]"
local GREEN="\[\033[0;32m\]"
local GREEN2="\[\033[0;32m\]"
local LIGHT_GREEN="\[\033[1;32m\]"
local WHITE="\[\033[1;37m\]"
local LIGHT_GRAY="\[\033[0;37m\]"
local MAGENTA="\[\033[1;35m\]"
local LIGHT_GRAY2="\[\033[0;37m\]"
local DARK_GRAY="\[\033[1;30m\]"
local YELLOW="\[\033[0;33m\]"
case $TERM in
xterm*)
TITLEBAR='\[\033]0;\u@\h:\w\007\]'
;;
*)
TITLEBAR=""
;;
esac
PS1="${TITLEBAR}\
$LIGHT_GRAY2[$CYAN\$(date +%H:%M)$LIGHT_GRAY2]\
$LIGHT_GRAY2[$CYAN\u@\h:$LIGHT_GRAY\w$MAGENTA\$(parse_git_branch)$LIGHT_GRAY2]\
$LIGHT_GRAY\n\$ "
PS2='> '
PS4='+ '
}
proml
