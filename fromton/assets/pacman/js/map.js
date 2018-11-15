function Map(levelMap, wallScale)
{
    this.levelMap = levelMap,

    this.generate = function()
    {
        function display(wall)
        {
            image = new Image();
            image.src = "/build/pacman/images/wall.png";

            if (wall === 1)
            {
                // game.ctx.fillStyle = "#1136FF";
                // game.ctx.fillRect(j * wallScale, i * wallScale, wallScale, wallScale);

                game.ctx.drawImage(image, 0, 0, 76, 76, j * wallScale, i * wallScale, wallScale, wallScale);
            }
            else if (wall === 0)
            {
                game.ctx.fillStyle = "#000";
                game.ctx.fillRect(j * wallScale, i * wallScale, wallScale, wallScale);

                food.display((j * wallScale) + (wallScale / 2), (i * wallScale) + (wallScale / 2));
            }
        }

        for (var i = 0; i < this.levelMap.length; i++)
        {
            for (var j = 0; j < this.levelMap[i].length; j++)
                display(this.levelMap[i][j]);
        }
    };
}