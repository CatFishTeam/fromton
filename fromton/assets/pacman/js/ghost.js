function Ghost(width, height, posX, posY, color)
{
    this.width = width,
    this.height = height,
    this.scale = 30,
    this.posX = posX * this.scale,
    this.posY = posY * this.scale,
    this.color = color,
    this.image = null,
    this.speed = 2.5,
    this.direction = 2,

    this.create = function(path)
    {
        path = path || false;

        if (path === false)
        {
            game.ctx.fillStyle = this.color;
            game.ctx.fillRect(this.posX, this.posY, this.width, this.height);
        }
        else
        {
            this.image = new Image();
            this.image.src = path;

            game.ctx.drawImage(this.image, 0, 0, this.width, this.height, this.posX, this.posY, this.scale, this.scale);
        }
    },

    this.move = function(direction)
    {
        this.onTheRight = firstMap[Math.floor((this.posY + (this.scale / 2)) / this.scale)][Math.floor((this.posX + this.scale) / this.scale)],
        this.onTheLeft = firstMap[Math.floor((this.posY + (this.scale / 2)) / this.scale)][Math.floor((this.posX - 1) / this.scale)],
        this.onTheTop = firstMap[Math.floor((this.posY - 1) / this.scale)][Math.floor((this.posX + (this.scale / 2)) / this.scale)],
        this.onTheBottom = firstMap[Math.floor((this.posY + this.scale) / this.scale)][Math.floor((this.posX + (this.scale / 2)) / this.scale)];

        if (Math.floor(this.posX / this.scale) > Math.floor(game.width / this.scale))
            this.posX = 0;
        else if (Math.floor(this.posX / this.scale) < 0)
            this.posX = game.width;

        if (Math.floor(player.posX / this.scale) == Math.floor(this.posX / this.scale) &&
            Math.floor(player.posY / this.scale) == Math.floor(this.posY / this.scale))
            game.play = false;

        if (this.direction === 0)
        {
            game.ctx.drawImage(this.image, 0, 0, this.width, this.height, this.posX, this.posY, this.scale, this.scale);

            if (this.onTheRight === 1)
            {
                this.direction = Math.floor(Math.random() * 4);
                return 0;
            }
            this.posX += this.speed;
        }
        else if (this.direction === 1)
        {
            game.ctx.drawImage(this.image, 0, this.height, this.width, this.height, this.posX, this.posY, this.scale, this.scale);

            if (this.onTheLeft === 1)
            {
                this.direction = Math.floor(Math.random() * 4);
                return 0;
            }
            this.posX -= this.speed;
        }
        else if (this.direction === 2)
        {
            game.ctx.drawImage(this.image, this.width, this.height, this.width, this.height, this.posX, this.posY, this.scale, this.scale);

            if (this.onTheTop === 1)
            {
                this.direction = Math.floor(Math.random() * 4);
                return 0;
            }
            this.posY -= this.speed;
        }
        else if (this.direction === 3)
        {
            game.ctx.drawImage(this.image, this.width, 0, this.width, this.height, this.posX, this.posY, this.scale, this.scale);

            if (this.onTheBottom === 1)
            {
                this.direction = Math.floor(Math.random() * 4);
                return 0;
            }
            this.posY += this.speed;
        }
    };
}