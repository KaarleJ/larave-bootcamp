export interface User {
  id: number;
  name: string;
  email: string;
  email_verified_at?: string;
  profile_picture?: string;
  username?: string;
  is_following?: boolean;
  is_social: boolean;
}

export interface Chirp {
  id: number;
  user: User;
  message: string;
  created_at: string;
  updated_at: string;
}

export type PageProps<
  T extends Record<string, unknown> = Record<string, unknown>
> = T & {
  auth: {
    user: User;
  };
};
