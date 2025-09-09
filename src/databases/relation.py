class Relation:
    from src.databases.model import Model

    def belongs_to(self, related:'Model', foreign_key, primary_key="id"): 
        value = self.attributes.get(foreign_key)
        if not value:
            return None
        return related.where(**{primary_key: value}).first()

    def has_many(self, related:'Model', foreign_key, primary_key="id"): 
        value = self.attributes.get(primary_key)
        if not value:
            return []
        return related.where(**{foreign_key: value})
    
    def has_one(self, related:'Model', foreign_key, primary_key="id"):
        value = self.attributes.get(primary_key)
        if not value:
            return None
        return related.where(**{foreign_key: value}).first()
    
    def belongs_to_many(self, related:'Model', pivot_table, foreign_key, related_key, primary_key="id", owner_key="id"):
        local_value = self.attributes.get(primary_key)
        if not local_value:
            return [] 
        rows = self.query_builder().select(pivot_table).where(**{foreign_key: local_value}).fetchall()
        related_ids = [row[related_key] for row in rows]

        if not related_ids:
            return []
        return related.where(**{owner_key: related_ids})
    
    def has_many_through(self, related:'Model', pivot_table, local_key, pivot_local, pivot_related, related_key):
        rows = self.query_builder().select(pivot_table).where(**{pivot_local: self.attributes[local_key]}).fetchall()
        ids = [row[pivot_related] for row in rows]
        return related.where(**{related_key: ids})
