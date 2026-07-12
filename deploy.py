import paramiko
import sys

def main():
    try:
        ssh = paramiko.SSHClient()
        ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
        ssh.connect('145.223.17.16', port=65002, username='u481666576', password='Abdul@a777')
        
        commands = [
            'sed -i \'s/"@context"/"@@context"/g\' /home/u481666576/domains/ashutosh-enterprises.in/public_html/resources/views/layouts/public.blade.php',
            'rm -rf /home/u481666576/domains/ashutosh-enterprises.in/public_html/storage/framework/views/*.php',
            'rm -rf /home/u481666576/domains/ashutosh-enterprises.in/public_html/bootstrap/cache/*.php'
        ]
        
        for cmd in commands:
            print(f"Running: {cmd}")
            stdin, stdout, stderr = ssh.exec_command(cmd)
            print(stdout.read().decode())
            print(stderr.read().decode())
            
        ssh.close()
    except Exception as e:
        print(f"Error: {e}")

if __name__ == '__main__':
    main()
