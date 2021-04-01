FROM sigver6/phpbq:0.0.1

# サービスアカウントキー(Projectを作ったら変更する必要があるので、jsonファイル名を固定しようか。
ADD xxx.json /opt/dataeng/
ENV GOOGLE_APPLICATION_CREDENTIALS=/opt/dataeng/xxx.json

# 実行ディレクトリに実行ファイルを追加
ADD hello.php /opt/dataeng/

