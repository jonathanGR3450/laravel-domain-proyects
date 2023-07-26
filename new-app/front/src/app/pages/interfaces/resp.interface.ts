import { Blog } from "./blog.interface";

export interface Resp {
    status:  string;
    message: string;
    data:    Blog[];
}