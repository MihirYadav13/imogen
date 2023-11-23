/**
 * IMPORTANT!!!!
 * READ THIS: https://wpack.io/guides/start-development-server/
 * 
 * 
 * If you are using something like XAMPP, in which your url is 
 * http://localhost/wp-project then what you ened to do is leave the proxy:
 * value as is, and udpate the distPublicPath parameter below with something 
 * like '/<subfolder>/wp-content/themes/fr-starter-theme/public/'
 * make sure subfolder matches the one youre using on XAMPP,
 * example: '/wp-project/wp-content/themes/fr-starter-theme/public/'
 * 
 * If you're not using xampp or using a custom URL for your local environment
 * please read the URL above 
 */

module.exports = {
	// Your LAN IP or host where you would want the live server
	// Override this if you know your correct external IP (LAN)
	// Otherwise, the system will always use localhost and will not
	// work for external IP.
	// This will also create some issues with file watching because for
	// some reason, service-worker doesn't work on localhost?
	// https://github.com/BrowserSync/browser-sync/issues/1295
	// So it is recommended to change this to your LAN IP.
	// If you intend to access it from your LAN (probably do?)
	// If you keep null, then wpackio-scripts will try to determine your LAN IP
	// on it's own, which might not always be satisfying. But it is in most cases.
	host: undefined,
	// Your WordPress development server address
	// This is super important
	proxy: 'http://localhost',
	// PORT on your localhost where you would want live server to hook
	port: 3000,
	// UI passed directly to browsersync
	ui: {
		port: 3001,
	},
	// Whether to show the "BrowserSync Connected"
	notify: false,
	// Open the local URL, set to false to disable
	open: true,
	// BrowserSync ghostMode, set to false to completely disable
	ghostMode: {
		clicks: true,
		scroll: true,
		forms: true,
	},
	// Override system calculated public path of the `dist` directory
	// This must have forward slash, otherwise it will not work.
	distPublicPath: false
};
