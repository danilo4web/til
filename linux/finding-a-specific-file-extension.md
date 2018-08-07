#finding a specific file extension
find . -name "*.txt" -type f

#finding a specific file extension and delete
find . -name "*.txt" -type f -delete

# do any command for each file
for i in *; do cat "$1"; done

Interesting:
https://www.hostinger.com.br/tutoriais/comandos-linux-find-e-locate/
