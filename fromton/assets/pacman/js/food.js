function Food(radius)
{
    this.radius = radius,
    this.scoreValue = 10,

    this.display = function(x, y)
    {
        game.ctx.fillStyle = "#FFFFFF";
        game.ctx.beginPath();
        game.ctx.arc(x, y, this.radius, 0, Math.PI * 360);
        game.ctx.fill();
    };
}