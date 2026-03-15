export interface INotification {
  id: string;
  type: string;
  notifiable_type: string;
  notifiable_id: number;
  data: {
    title: string;
    message: string;
    body: string;
    action_url?: string;
    [key: string]: any;
  };
  read_at: string | null;
  created_at: string;
  updated_at: string;
}