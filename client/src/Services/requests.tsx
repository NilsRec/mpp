export const backendUrl =
  process.env.NODE_ENV === 'production' ? 'https://api.mpm.reconnect.fr' : 'http://localhost:8000';
export const apiEndpoint = `${backendUrl}/api`;

export const userEndpoint = `${apiEndpoint}/people`;
export const loginEndpoint = `${backendUrl}/authentication_token`;
export const notesEndpoint = `${apiEndpoint}/notes`;
