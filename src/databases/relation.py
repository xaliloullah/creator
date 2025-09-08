class Relation:  
    from src.databases import Model

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
        rows = model.provider.select(pivot_table).where(**{foreign_key: local_value}).fetchall()
        related_ids = [row[related_key] for row in rows]

        if not related_ids:
            return []
        return related.where(**{owner_key: related_ids})
    
    def belongs_to(self, related:'Model', foreign_key, primary_key=primary_key): 
        value = self.attributes.get(foreign_key)
        if not value:
            return None
        return related.where(**{primary_key: value}).first()

    def has_many(self, related:'Model', foreign_key, primary_key=primary_key): 
        value = self.attributes.get(primary_key)
        if not value:
            return []
        return related.where(**{foreign_key: value})
    
    def has_one(self, related:'Model', foreign_key, primary_key=primary_key):
        value = self.attributes.get(primary_key)
        if not value:
            return None
        return related.where(**{foreign_key: value}).first()
    
    def belongs_to_many(self, related:'Model', pivot_table, foreign_key, related_key, primary_key=primary_key, owner_key=primary_key):
        local_value = self.attributes.get(primary_key)
        if not local_value:
            return [] 
        rows = self.provider.select(pivot_table).where(**{foreign_key: local_value}).fetchall()
        related_ids = [row[related_key] for row in rows]

        if not related_ids:
            return []
        return related.where(**{owner_key: related_ids})
    
    def has_many_through(self, related:'Model', pivot_table, local_key, pivot_local, pivot_related, related_key):
        rows = self.provider.select(pivot_table).where(**{pivot_local: self.attributes[local_key]}).fetchall()
        ids = [row[pivot_related] for row in rows]
        return related.where(**{related_key: ids})