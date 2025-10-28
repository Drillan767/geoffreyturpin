const TOKEN_KEY = 'jwt_token'

export const getToken = (): string | null => {
  if (typeof window === 'undefined') return null
  return localStorage.getItem(TOKEN_KEY)
}

export const setToken = (token: string): void => {
  if (typeof window === 'undefined') return
  localStorage.setItem(TOKEN_KEY, token)
}

export const removeToken = (): void => {
  if (typeof window === 'undefined') return
  localStorage.removeItem(TOKEN_KEY)
}

export const isAuthenticated = (): boolean => {
  return !!getToken()
}

export const login = async (email: string, password: string): Promise<void> => {
  const { apiClient } = await import('./api')

  const response = await apiClient.post('/login', {
    email,
    password,
  })

  if (response.data.token) {
    setToken(response.data.token)
  } else {
    throw new Error('No token received')
  }
}

export const logout = (): void => {
  removeToken()
}
