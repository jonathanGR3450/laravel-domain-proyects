export interface User {
    id?:                string;
    name?:              string;
    last_name?:         string;
    email?:             string;
    identification?:    number;
    cell_phone?:        string;
    city?:              string;
    address?:           string;
    city_register?:     string;
    is_manager?:        boolean;
    is_signer?:         boolean;
    is_verified?:       string;
    status?:            boolean;
    email_verified_at?: Date;
    created_at?:        Date;
    updated_at?:        Date;
}