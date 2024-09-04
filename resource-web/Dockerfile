FROM php:8.0-apache

# 必要なPHP拡張をインストール
RUN echo "Installing pdo_mysql..." \
    && docker-php-ext-install pdo_mysql \
    && echo "pdo_mysql installed successfully"

# Apacheのドキュメントルートを設定
WORKDIR /var/www/html

# ソースコードをコンテナ内にコピー
COPY . /var/www/html

# ポートの公開
EXPOSE 80