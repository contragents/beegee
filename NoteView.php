<?php

namespace View;

class NoteView extends BaseView
{
	public static function render($data)
	{
		$prepared_data='';
		if (isset($data['text']))
			$prepared_data .= $data['text'];
		$prepared_data .= "<table class=\"table\">";
		if (isset($data['rows']))
		{
			$prepared_data .= "<tr><td>Имя пользователя&nbsp;<a title=\"Упорядочить по убыванию\" href=\"/?sorting=username\">&dArr;</a>&nbsp;<a title=\"Упорядочить по возрастанию\" href=\"/?sorting=username&direction=ASC\">&uArr;</a></td><td>Емейл&nbsp;<a title=\"Упорядочить по убыванию\" href=\"/?sorting=email\">&dArr;</a>&nbsp;<a title=\"Упорядочить по возрастанию\" href=\"/?sorting=email&direction=ASC\">&uArr;</a></td><td>Текст задачи</td><td>Статус&nbsp;<a title=\"Упорядочить по убыванию\" href=\"/?sorting=status\">&dArr;</a>&nbsp;<a title=\"Упорядочить по возрастанию\" href=\"/?sorting=status&direction=ASC\">&uArr;</a></td><td>Отредактировано администратором</td></tr>";
			foreach($data['rows'] as $num => $row)
				$prepared_data .= "<tr>
				<td>{$row['username']}</td>
				<td>{$row['email']}</td>
				<td>
				".(\App\Application::IsAdmin() ? "<FORM id=\"{$row['id']}\" method=\"post\" action=\"/note/edit?id={$row['id']}{$data['sorting']}".($data['page']>1 ? "&page={$data['page']}": '')."\"><input type=\"text\" name=\"text\" value=\"".htmlspecialchars($row['text'])."\" size= \"50\" />&nbsp;<input type=\"submit\" value=\"Отправить\"/></FORM>" : htmlspecialchars($row['text']))."
				</td>
				<td>
				<input id=\"checkbox{$row['id']}\" type=\"checkbox\" ". ($row['status'] == 1 ? "checked" : "") ." ".(\App\Application::IsAdmin() ? "onClick=\"location.href='/note/aquire?id={$row['id']}{$data['sorting']}".($data['page']>1 ? "&page={$data['page']}": '')."&status='+document.getElementById('checkbox{$row['id']}').value\"" : "disabled")." /> 
				</td>
				<td>
				{$row['is_modified']}
				</td>
				</tr>";
			
		}
		$prepared_data .= "<tr>
		<FORM method=\"post\" action=\"/note/add\">
		<td><input  type=\"text\" name=\"username\" placeholder=\"Имя пользователя\"/></td>
		<td><input type=\"email\" name=\"email\" placeholder=\"Email\"/></td>
		<td><input  type=\"text\" name=\"text\" placeholder=\"Текст задания\" size= \"50\" /></td>
		<td><input type=\"submit\" value=\"Добавить задачу\" /></td>
		<td></td>
		</FORM>
		</tr>";
		$prepared_data .= "</table>";
		
		if (isset($data['num_rows']))
		{
			$prepared_data .= "Пагинация для {$data['num_rows']} записей..";
			for($i=1;$i<=ceil($data['num_rows']/3);$i++)
				if ($i==$data['page'])
					$prepared_data .= '&nbsp;'.$i.'&nbsp;';
				else
					$prepared_data .= '&nbsp;<a href="/?page='.$i.$data['sorting'].'">'.$i.'</a>&nbsp;';
		}
			
			
		return parent::render($prepared_data);
	}
	
	
}
?>