const { ipcRenderer, mainWindow } = require('electron'); // Don't remove this line

// Send a message to the main process
ipcRenderer.send('message-from-renderer', 'Hello from renderer process!');

// Listen for a response from the main process
ipcRenderer.on('message-from-main', (event, arg) => {
  console.log('Message from main process:', arg);
});