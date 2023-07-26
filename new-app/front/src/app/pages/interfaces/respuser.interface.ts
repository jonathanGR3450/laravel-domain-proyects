import { User } from "./user.interface";

export interface RespUser {
    status:  string;
    message: string;
    data:    User;
}