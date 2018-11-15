function Player(width, height, posX, posY, color)
{
    this.width = width,
    this.height = height,
    this.scale = 30,
    this.posX = posX * this.scale,
    this.posY = posY * this.scale,
    this.color = color,
    this.image = null,
    this.onTheRight = null,
    this.onTheLeft = null,
    this.onTheTop = null,
    this.onTheBottom = null,
    this.speed = 2,
    this.direction = 0,
    this.score = 0,

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
        }
    },

    this.move = function()
    {
        this.onTheRight = firstMap[Math.floor((this.posY + (this.scale / 2)) / this.scale)][Math.floor((this.posX + this.scale) / this.scale)];
        this.onTheLeft = firstMap[Math.floor((this.posY + (this.scale / 2)) / this.scale)][Math.floor((this.posX - 1) / this.scale)];
        this.onTheTop = firstMap[Math.floor((this.posY - 1) / this.scale)][Math.floor((this.posX + (this.scale / 2)) / this.scale)];
        this.onTheBottom = firstMap[Math.floor((this.posY + this.scale) / this.scale)][Math.floor((this.posX + (this.scale / 2)) / this.scale)];

        if (Math.floor(this.posX / this.scale) > Math.floor(game.width / this.scale))
            this.posX = 0;
        else if (Math.floor(this.posX / this.scale) < 0)
            this.posX = game.width;

        if (this.direction === 0)
        {
            game.ctx.drawImage(this.image, 0, 0, this.width, this.height, this.posX, this.posY, this.scale, this.scale);

            if (this.onTheRight === 1)
                return 0;
            else if (this.onTheRight === 0)
            {
                firstMap[Math.floor((this.posY + (this.scale / 2)) / this.scale)][Math.floor((this.posX + this.scale) / this.scale)] = 2;
                this.score += food.scoreValue;
            }
            this.posX += this.speed;
        }
        else if (this.direction === 1)
        {
            game.ctx.drawImage(this.image, 0, this.height, this.width, this.height, this.posX, this.posY, this.scale, this.scale);

            if (this.onTheLeft === 1)
                return 0;
            else if (this.onTheLeft === 0)
            {
                firstMap[Math.floor((this.posY + (this.scale / 2)) / this.scale)][Math.floor((this.posX - 1) / this.scale)] = 2;
                this.score += food.scoreValue;
            }
            this.posX -= this.speed;
        }
        else if (this.direction === 2)
        {
            game.ctx.drawImage(this.image, this.width, this.height, this.width, this.height, this.posX, this.posY, this.scale, this.scale);

            if (this.onTheTop === 1)
                return 0;
            else if (this.onTheTop === 0)
            {
                firstMap[Math.floor((this.posY - 1) / this.scale)][Math.floor((this.posX + (this.scale / 2)) / this.scale)] = 2;
                this.score += food.scoreValue;
            }
            this.posY -= this.speed;
        }
        else if (this.direction === 3)
        {
            game.ctx.drawImage(this.image, this.width, 0, this.width, this.height, this.posX, this.posY, this.scale, this.scale);

            if (this.onTheBottom === 1)
                return 0;
            else if (this.onTheBottom === 0)
            {
                firstMap[Math.floor((this.posY + this.scale) / this.scale)][Math.floor((this.posX + (this.scale / 2)) / this.scale)] = 2;
                this.score += food.scoreValue;
            }
            this.posY += this.speed;
        }
    };
}