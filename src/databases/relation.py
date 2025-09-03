class Relation:  
    from src.models import Model

    def belongs_to(model:'Model', related:'Model', foreign_key, primary_key="id"): 
        value = model.attributes.get(foreign_key)
        if not value:
            return None
        return related.where(**{primary_key: value}).first()

    def has_many(model:'Model', related:'Model', foreign_key, primary_key="id"): 
        value = model.attributes.get(primary_key)
        if not value:
            return []
        return related.where(**{foreign_key: value})
    
    def has_one(model:'Model', related:'Model', foreign_key, primary_key="id"):
        value = model.attributes.get(primary_key)
        if not value:
            return None
        return related.where(**{foreign_key: value}).first()
    
    def belongs_to_many(model:'Model', related:'Model', pivot_table, foreign_key, related_key, local_key="id", owner_key="id"):
        local_value = model.attributes.get(local_key)
        if not local_value:
            return [] 
        rows = model.driver.select(pivot_table).where(**{foreign_key: local_value}).fetchall()
        related_ids = [row[related_key] for row in rows]

        if not related_ids:
            return []
        return related.where(**{owner_key: related_ids})