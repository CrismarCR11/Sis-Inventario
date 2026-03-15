import { useToast } from 'vue-toastification'

const toast = useToast()

type NotificationType = 'success' | 'error' | 'warning' | 'info'

interface NotificationOptions {
  text: string
  type?: NotificationType
  timeout?: number
}

export function showNotification({ text, type = 'success', timeout = 3000 }: NotificationOptions): void {
  toast(text, { 
    type: type as any, 
    timeout,
    draggable: true,      // Permitir arrastrar para cerrar
    draggablePercent: 0.6
  });
}

export const noty = {
  success: (text: string) => showNotification({ text, type: 'success' }),
  error: (text: string) => showNotification({ text, type: 'error', timeout: 4000 }),
  warning: (text: string) => showNotification({ text, type: 'warning' }),
  info: (text: string) => showNotification({ text, type: 'info' })
}