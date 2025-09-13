class Validator:
    def __init__(self) -> None:   
        self.errors = [] 
    
    def validate(self, validate: dict, data: dict):
        for field, rules in validate.items():
            value = data.get(field)
            for rule in rules:
                rule = str(rule)
                if rule == "required":
                    if not value: 
                        self.set_error(rule, field) 
                
                if rule == "nullable":
                    pass
                    
                if rule == "numeric":
                    if value and not isinstance(value, (int, float)):
                        self.set_error(rule, field) 
                
                if rule == "boolean":
                    if value and not isinstance(value, bool):
                        self.set_error(rule, field) 
                        
                if rule == "string":
                    if value and not isinstance(value, str):
                        self.set_error(rule, field) 
               
                if rule == "email":
                    if value and (not isinstance(value, str) or "@" not in value or "." not in value):
                        self.set_error(rule, field) 
                                                           
                if rule == "password": 
                    from src.validators import Password
                    password = Password(value, field).default()
                    if password.errors:
                        for error in password.errors:
                            self.errors.append(error) 

                if rule.startswith("min") and "integer" in rules:
                    if value:
                        min_val = int(rule.split(":")[1]) 
                        if int(value) < min_val:
                            self.set_error("min", field, min=min_val) 

                if rule.startswith("max") and "integer" in rules:
                    if value:
                        max_val = int(rule.split(":")[1])
                        if int(value) > max_val:
                            self.set_error("max", field, max=max_val) 

                if rule.startswith("minlength"):
                    if value:
                        min_len = int(rule.split(":")[1])
                        if len(str(value)) < min_len:
                            self.set_error("minlength", field, min=min_len)

                if rule.startswith("maxlength"):
                    if value:
                        max_len = int(rule.split(":")[1])
                        if len(str(value)) > max_len:
                            self.set_error("maxlength", field, max=max_len) 
                
                if rule == "integer":
                    if value:
                        try:
                            int(value)
                        except ValueError:
                            self.set_error(rule, field) 
                 
                if rule == "decimal":
                    if value:
                        try:
                            float(value)
                        except ValueError: 
                            self.set_error(rule, field) 
                        
                if rule == "array":
                    if value:
                        if not isinstance(value, list):
                            self.set_error(rule, field) 
                            
                if rule == "object":
                    if value:
                        if not isinstance(value, object):
                            self.set_error(rule, field) 
                            
                if rule == "phone":
                    if value and (not isinstance(value, str) or len(value) < 10):
                        self.set_error(rule, field)
                        
                if rule == "date":
                    if value:
                        try:
                            from src.core import Date
                            Date(value).to_string() 
                        except ValueError:
                            self.set_error(rule, field) 
                            
                if rule == "file":
                    if value:
                        if not isinstance(value, dict):
                            self.set_error(rule, field) 
                            
                if rule == "image":
                    if value:
                        if not isinstance(value, dict):
                            self.set_error(rule, field) 
                            
                if rule == "video":
                    if value:
                        if not isinstance(value, dict):
                            self.set_error(rule, field)

                if rule == "audio":
                    if value:
                        if not isinstance(value, dict):
                            self.set_error(rule, field)
                            
                if rule == "document":
                    if value:
                        if not isinstance(value, dict):
                            self.set_error(rule, field)

                if rule == "url":
                    if value:
                        if not isinstance(value, str) or not value.startswith("http"):
                            self.set_error(rule, field)
                            
                if rule == "ip":
                    if value:
                        if not isinstance(value, str) or not value.count(".") == 3:
                            self.set_error(rule, field)
                            
                if rule == "ipv4":
                    if value:
                        if not isinstance(value, str) or not value.count(".") == 3:
                            self.set_error(rule, field)
                            
                if rule == "ipv6":
                    if value:
                        if not isinstance(value, str) or not value.count(":") == 7:
                            self.set_error(rule, field)
                             
                if rule == "mac":
                    if value:
                        if not isinstance(value, str) or not value.count(":") == 5:
                            self.set_error(rule, field)
                            
                if rule == "uuid":
                    if value:
                        try:
                            import uuid 
                            uuid.UUID(value, version=4)
                        except ValueError:
                            self.set_error(rule, field)
                            
                if rule == "json":
                    if value:
                        try:
                            import json
                            json.loads(value)
                            pass
                        except ValueError:
                            self.set_error(rule, field)
                             
                if rule == "alpha":
                    if value and not value.isalpha():
                        self.set_error(rule, field)
                
                if rule == "alphanumeric":
                    if value and not value.isalnum():
                        self.set_error(rule, field)  
                       
                if rule.startswith("unique"):
                    params = rule.split(":")[1].split(",")
                    table = str(params[0])
                    ignore = params[1] if len(params) > 1 else None 
                    if table:
                        from src.databases.model import Model
                        Model.table = table
                        # .where_not(ignore)
                        row = Model.where(**{field: value}).count()
                        if row:
                            self.set_error("unique", field) 
                                    
                if rule.startswith("exist"):
                    if value:
                        params = rule.split(":")[1].split(",")
                        table = params[0]
                        if table:
                            from src.databases.model import Model
                            rows = Model(table).where(**{field: value})
                            if not rows.exists():
                                self.set_error("exist", field) 

        return not self.has_errors()

    def has_errors(self):
        return bool(self.errors)
    
    def get_errors(self):
        errors = self.errors[:]
        self.errors.clear()
        return errors
    
    def set_error(self, key, field, **kwargs):
        from src.application import Creator 
        self.errors.append(Creator.lang.get(f"validation.{key}", attribute=field, **kwargs))

            
