FROM node:18

WORKDIR /app

# Copia os arquivos package.json e package-lock.json (ou yarn.lock)
COPY package*.json ./

# Instala as dependências
RUN npm install

# Copia o restante do código fonte
COPY . .

# Expõe a porta 4200 (Angular CLI)
EXPOSE 4200

# Inicia o servidor de desenvolvimento do Angular CLI
CMD ["npm", "start", "--", "--host=0.0.0.0", "--poll=2000"]