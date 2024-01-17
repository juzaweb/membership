const mix = require('laravel-mix');
const path = require('path');

const baseAsset = path.resolve(__dirname, '');
const baseStyles = baseAsset + '/styles';
const basePublish = baseAsset + '/public';

mix.styles(
    [
        baseStyles + '/css/frontend/pricing.css',
    ],
    `${basePublish}/css/frontend/pricing.min.css`
);
mix.combine(
    [
        `${baseStyles}/js/frontend/pricing.js`,
    ],
    `${basePublish}/js/frontend/pricing.min.js`
);
